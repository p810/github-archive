<?php

namespace p810\Amethyst\Session\Strategy;

use p810\Amethyst\Application;

class MySQL implements \SessionHandlerInterface
{
    /**
     * Declares the table where session data is meant to be stored and resolves an instance of p810\Amethyst\Database\MySQL.
     *
     * @param string $table The table which holds session data.
     * @return void
     */
    function __construct($table = 'sessions')
    {
        $app = Application::getInstance();

        $this->database = $app->single('Database.MySQL');

        $this->table = $table;
    }

    
    /**
     * @see <http://php.net/manual/en/sessionhandlerinterface.read.php>
     */
    public function read($id)
    {
        $data = $this->database->select('*', $this->table)->where('session_id', $id)->execute();

        if ($data === false || empty($data)) {
            return '';
        }

        return $data[0]['data'];
    }


    /**
     * @see <http://php.net/manual/en/sessionhandlerinterface.write.php>
     */
    public function write($id, $data)
    {
        $old = $this->read($id);

        if (!empty($old)) {
            $result = $this->database->update($this->table, [
                'session_id' => $id,
                'data'       => $data
            ])->where('session_id', $id)->execute();
        } else {
            $result = $this->database->insert($this->table, [
                'session_id' => $id,
                'data'       => $data
            ])->execute();
        }

        if ($result === false) {
            throw new \Exception('Failed to write session data to the database');

            return false;
        }

        return true;
    }


    /**
     * @see <http://php.net/manual/en/sessionhandlerinterface.destroy.php>
     */
    public function destroy($id)
    {
        $result = $this->database->delete($this->table)->where('session_id', $id)->execute();

        if ($result === false) {
            throw new \Exception('Failed to remove session data from the database');

            return false;
        }

        return true;
    }


    /**
     * @see <http://php.net/manual/en/sessionhandlerinterface.gc.php>
     */
    public function gc($maxlifetime)
    {
        $expired = time() - $maxlifetime;

        $rows = $this->database->delete($this->table)->where('timestamp', '>', $expired)->execute();

        if ($rows === false) {
            throw new \Exception('Garbage collector failed to remove old session data from the database');

            return false;
        }

        return true;
    }

    
    /**
     * These methods are required to be added to remain compliant with SessionHandlerInterface, though we don't need them
     * in this implementation.
     *
     * @return void
     */
    public function close() {}
    public function open($a, $b) {}
}