<?php

class Delta {
    /**
     * Returns a delta based on a list of values supplied.
     * 
     * @param int[] $values
     * @return int[]
     */
    public function encode(array $values): array {
        $buffer = [];
        $length = count($values);

        $prev = 0;
        for ($i = 0; $i < $length; $i++) {
            $curr = $values[$i];

            $buffer[] = $curr - $prev;
    
            $prev = $curr;
        }

        return $buffer;
    }

    /**
     * Returns the original values from a delta.
     * 
     * @param int[] $delta
     * @return int[]
     */
    public function decode(array $delta): array {
        $first = $last = $delta[0];
        
        $buffer = [];
        $length = count($delta) - 1;

        for ($i = 1; $i < $length; $i++) {
            $last = $buffer[] = $delta[$i] + $last;
        }

        array_unshift($buffer, $first);

        return $buffer;
    }

    /**
     * Returns the difference of two deltas.
     * 
     * @param int[] $x
     * @param int[] $y
     * @return int[]
     */
    public function diff(array $x, array $y): array {
        $buffer = [];
        
        foreach ($y as $k => $v) {
            $buffer[] = $v - $x[$k];
        }

        return $buffer;
    }
}
