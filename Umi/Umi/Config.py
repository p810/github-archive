# Umi is a simple IRC client

class Config:

  def __init__(self):
    self.conf = {
      'network' : {
        'addr' : '127.0.0.1',
        'port' : 6667
      },

      'identity' : {
        'name' : 'Umi',
        'nick' : 'Umi',
        'pass' : 'password'
      },

      'sql' : {
        'enabled'  : True,
        'database' : 'Umi',
        'table'    : 'logs'
      },

      'dev' : {
        'out'    : True,
        'log'    : None,
        'notify' : False
      }
    }

  def network(self):
    return ( 
      self.conf['network']['addr'], 
      self.conf['network']['port'] 
    )

  def identity(self):
    return (
      self.conf['identity']['name'],
      self.conf['identity']['nick'],
      self.conf['identity']['pass']
    )

  def notify(self):
    return self.conf['dev']['notify']

  def debug(self):
    return self.conf['dev']['debug']

  def log(self):
    return self.conf['dev']['log']

  def all(self):
    return self.conf

  def sql(self):
    if not self.conf['sql']['enabled']:
      return None
    else:
      return (
        self.conf['sql']['database'],
        self.conf['sql']['table']
      )