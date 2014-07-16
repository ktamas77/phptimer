<?php

/**
 * PHPTimer Class
 *
 * PHP version 5
 * 
 * @category  Profiling
 * @package   PHPTimer
 * @author    Tamas Kalman <ktamas77@gmail.com>
 * @copyright 2007,2012 (c) Tamas Kalman
 * @link      https://github.com/ktamas77/phptimer
 * 
 */
class Timer
{

    var $_privateTime;
    var $_timeArray;
    var $_timerMask;

    function __construct()
    {
        $this->_privateTime = Array();
        $this->_timeArray = Array();
        $this->_timerMask = '%01.2f';
    }

    /**
     * Starts a timer with a specified label
     * 
     * @param String $label Name of the timer
     * 
     * @return void
     */
    public function start($label)
    {
        $this->_timeArray[$label]['start'] = $this->_getTime();
        $this->_timeArray[$label]['stop'] = 0;
        if (!isset($this->_timeArray[$label]['starts'])) {
            $this->_timeArray[$label]['starts'] = 1;
        } else {
            $this->_timeArray[$label]['starts']++;
        }
        if (!isset($this->_privateTime [$label]['allranges'])) {
            $this->_privateTime[$label]['allranges'] = 0;
        }
    }

    /**
     * Stops a timer with the specified label (if exists)
     * 
     * @param String $label Name of the timer
     * 
     * @return void 
     */
    public function stop($label)
    {
        if (isset($this->_timeArray[$label]['stop'])) {
            $this->_timeArray[$label]['stop'] = $this->_getTime();
            $this->_privateTime[$label]['allranges'] += $this->_timeArray[$label]['stop'] - $this->_timeArray[$label]['start'];
        }
    }

    /**
     * Restarts a timer with the specified label (if exists)
     * 
     * @param String $label Name of the timer 
     * 
     * @return void
     */
    public function restart($label)
    {
        if (isset($this->_timeArray[$label]['stop'])) {
            unset($this->_privateTime[$label]['allranges']);
        }
        $this->start($label);
    }

    /**
     * Stops all timers
     * 
     * @return void 
     */
    public function stopAll()
    {
        foreach ($this->_timeArray as $label => $value) {
            $this->stop($label);
        }
    }

    /**
     * Deletes a timer
     * 
     * @param String $label Name of the timer
     * 
     * @return void
     */
    public function del($label)
    {
        if (isset($this->_timeArray[$label])) {
            unset($this->_timeArray[$label]);
        }
    }

    /**
     * Deletes all timers
     * 
     * @return void 
     */
    public function delAll()
    {
        $this->_timeArray = Array();
    }

    /**
     * Returns the actual state of a timer
     * 
     * @param String $label TImer Name
     * 
     * @return Array|Boolean Timer Data or False if there is no such timer 
     */
    public function get($label)
    {
        if (isset($this->_timeArray[$label])) {
            $this->_extendRecord($label);
            return $this->_timeArray[$label];
        } else {
            return false;
        }
    }

    /**
     * Returns with all timers' data
     * 
     * @return Array 
     */
    public function getAll()
    {
        foreach (array_keys($this->_timeArray) as $label) {
            $this->_extendRecord($label);
        }
        return $this->_timeArray;
    }
    
    /**
     * Sets timer mask for human readable format
     * 
     * @param String $mask mask
     * 
     * @return void
     */
    public function setTimerMask($mask) {
        $this->_timerMask = $mask;
    }
    
    /**
     * Returns with current timer mask
     * 
     * @return String Timer Mask 
     */
    public function getTimerMask() {
        return $this->_timerMask;
    }

    /**
     * Actual Time
     * 
     * @return String Time 
     */
    private function _getTime()
    {
        $time = microtime();
        $time = explode(' ', $time);
        $time = $time [1] + $time [0];
        return $time;
    }

    /**
     * Extends the current state of a timer with human readable information
     * 
     * status       : running|stopped
     * range        : all active running ranges combined for the label
     * average      : range / original start time
     * average_human: average in human readable format
     * range_human  : range length in human readable format
     * 
     * @param String $label Name of the timer
     * 
     * @return void
     */
    private function _extendRecord($label)
    {
        $value = &$this->_timeArray[$label];
        if ($value['stop'] > 0) {
            $value['range'] = $this->_privateTime[$label]['allranges'];
            $value['status'] = 'stopped';
        } else {
            $value['range'] = ($this->_getTime() - $value ['start']) + $this->_privateTime[$label]['allranges'];
            $value['status'] = 'running';
        }
        $value['average'] = $value['range'] / $value['starts'];
        $value['average_human'] = sprintf($this->getTimerMask(), $value['average']);
        $value['range_human'] = sprintf($this->getTimerMask(), $value['range']);
    }
    
}
