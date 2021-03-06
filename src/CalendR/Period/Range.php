<?php

/*
 * This file has been added to CalendR, a Fréquence web project.
 *
 * (c) 2012 Ingewikkeld/Stefan Koopmanschap
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CalendR\Period;

/**
 * Represents a Range
 *
 * @author Stefan Koopmanschap <left@leftontheweb.com>
 */
class Range extends PeriodAbstract
{
    public function __construct(\DateTime $begin, \DateTime $end)
    {
        $this->begin = clone $begin;
        $this->end = clone $end;
    }

    /**
     * @param \DateTime $date
     * @return true if the period contains this date
     */
    public function contains(\DateTime $date)
    {
        return ($date->format('U') > $this->begin->format('U') && $date->format('U') < $this->end->format('U'));
    }

    public static function isValid(\DateTime $start)
    {
        return true;
    }

    /**
     * @return Day
     */
    public function getNext()
    {
        $diff = $this->begin->diff($this->end);
        $begin = clone($this->begin);
        $begin->add($diff);
        $end = clone($this->end);
        $end->add($diff);

        return new self($begin, $end);
    }

    /**
     * @return Day
     */
    public function getPrevious()
    {
        $diff = $this->begin->diff($this->end);
        $begin = clone($this->begin);
        $begin->sub($diff);
        $end = clone($this->end);
        $end->sub($diff);

        return new self($begin, $end);
    }

    /**
     * Returns the period as a DatePeriod
     *
     * @return \DatePeriod
     */
    public function getDatePeriod()
    {
        return new \DatePeriod($this->begin, $this->begin->diff($this->end), $this->end);
    }

    /**
     * Returns a \DateInterval equivalent to the period
     *
     * @static
     * @return \DateInterval
     */
    static function getDateInterval()
    {
      throw new Exception\NotImplemented('Range period doesn\'t support getDateInterval().');
    }
}
