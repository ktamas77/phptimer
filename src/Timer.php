<?php

namespace ktamas77\phptimer;

/**
 * PHPTimer Class
 *
 * PHP version 7.3
 *
 * @category  Profiling
 * @package   PHPTimer
 * @author    Tamas Kalman <ktamas77@gmail.com>
 * @copyright 2007, 2020 (c) Tamas Kalman
 * @link      https://github.com/ktamas77/phptimer
 *
 */
class Timer
{

    private $privateTime;
    private $timeArray;
    private $timerMask;

    function __construct()
    {
        $this->privateTime = [];
        $this->timeArray = [];
        $this->timerMask = '%01.2f';
    }

    /**
     * Starts a timer with a specified label
     *
     * @param string $label Name of the timer
     * @return void
     */
    public function start(string $label): void
    {
        $this->timeArray[$label]['start'] = $this->getTime();
        $this->timeArray[$label]['stop'] = 0;
        if (!isset($this->timeArray[$label]['starts'])) {
            $this->timeArray[$label]['starts'] = 0;
        }
        $this->timeArray[$label]['starts']++;
        if (!isset($this->privateTime [$label]['allranges'])) {
            $this->privateTime[$label]['allranges'] = 0;
        }
    }

    /**
     * Stops a timer with the specified label (if exists)
     *
     * @param string $label Name of the timer
     * @return void
     */
    public function stop(string $label): void
    {
        if (isset($this->timeArray[$label]['stop'])) {
            $this->timeArray[$label]['stop'] = $this->getTime();
            $this->privateTime[$label]['allranges'] += $this->timeArray[$label]['stop'] - $this->timeArray[$label]['start'];
        }
    }

    /**
     * Restarts a timer with the specified label (if exists)
     *
     * @param string $label Name of the timer
     * @return void
     */
    public function restart(string $label): void
    {
        if (isset($this->timeArray[$label]['stop'])) {
            unset($this->privateTime[$label]['allranges']);
        }
        $this->start($label);
    }

    /**
     * Stops all timers
     *
     * @return void
     */
    public function stopAll(): void
    {
        foreach ($this->timeArray as $label => $value) {
            $this->stop($label);
        }
    }

    /**
     * Deletes a timer
     *
     * @param string $label Name of the timer
     * @return void
     */
    public function del(string $label): void
    {
        if (isset($this->timeArray[$label])) {
            unset($this->timeArray[$label]);
        }
    }

    /**
     * Deletes all timers
     *
     * @return void
     */
    public function delAll(): void
    {
        $this->timeArray = [];
    }

    /**
     * Returns the actual state of a timer
     *
     * @param string $label Timer Name
     * @return array|boolean Timer Data or False if there is no such timer
     */
    public function get(string $label)
    {
        if (isset($this->timeArray[$label])) {
            $this->extendRecord($label);
            return $this->timeArray[$label];
        }
        return false;
    }

    /**
     * Returns with all timers' data
     *
     * @return array
     */
    public function getAll(): array
    {
        foreach (array_keys($this->timeArray) as $label) {
            $this->extendRecord($label);
        }
        return $this->timeArray;
    }

    /**
     * Sets timer mask for human readable format
     *
     * @param string $mask mask
     * @return void
     */
    public function setTimerMask(string $mask): void
    {
        $this->timerMask = $mask;
    }

    /**
     * Returns with current timer mask
     *
     * @return string Timer Mask
     */
    public function getTimerMask(): string
    {
        return $this->timerMask;
    }

    /**
     * Actual Time
     *
     * @return string Time
     */
    private function getTime(): string
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
     * @param string $label Name of the timer
     * @return void
     */
    private function extendRecord(string $label): void
    {
        $value = &$this->timeArray[$label];
        if ($value['stop'] > 0) {
            $value['range'] = $this->privateTime[$label]['allranges'];
            $value['status'] = 'stopped';
        } else {
            $value['range'] = ($this->getTime() - $value ['start']) + $this->privateTime[$label]['allranges'];
            $value['status'] = 'running';
        }
        $value['average'] = $value['range'] / $value['starts'];
        $value['average_human'] = sprintf($this->getTimerMask(), $value['average']);
        $value['range_human'] = sprintf($this->getTimerMask(), $value['range']);
    }
}
