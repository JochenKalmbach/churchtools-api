<?php
declare(strict_types=1);

namespace ChurchTools\Api;

use ChurchTools\Api\Booking;

/**
 * A single calendarentry, with bookings if any
 *
 * @author André Schild
 */
class CalendarEntry extends CTObject
{
    private $startDate;
    private $endDate;
    private $title;
    private $calendarID;
    private $calendarName;
    private $remarks;
    private $moreInfos;
    private $link;
    private $bookings;

    /**
     * @overridedoc
     */
    protected function handleDataBlock($blockName, $blockData): void
    {
        switch ($blockName) {
            case 'startdate': $this->startDate    = $this->parseDateTime($blockData);
                break;
            case 'enddate': $this->endDate      = $this->parseDateTime($blockData);
                if ($this->isFullDayEvent($this->startDate, $this->endDate))
                {
                    $this->endDate= $this->makeFullDayEvent($this->endDate);
                }
                break;
            case 'bezeichnung': $this->title        = $blockData;
                break;
            case 'notizen': $this->moreInfos        = $blockData;
                break;
            case 'link': $this->link        = $blockData;
                break;
            case 'ort': $this->remarks      = $blockData;
                break;
            case 'category_id': $this->calendarID   = intval($blockData);
                break;
            case 'category_name': $this->calendarName = $blockData;
                break;
            case 'bookings':
                $bookings           = [];
                foreach ($blockData as $b) {
                    array_push($bookings, new Booking($b));
                }
                $this->bookings = $bookings;
                break;
            default:
                parent::handleDataBlock($blockName, $blockData);
        }
    }

    /**
     * @return \DateTime start date of calendar entry
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    /**
     * @return date end date of calenda entry
     */
    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    /**
     * @return string title of calenda entry
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string remarks of calendar entry
     */
    public function getRemarks(): ?string
    {
        return $this->remarks;
    }

    /**
     * @return string moreInfos of calendar entry
     */
    public function getMoreInfos(): ?string
    {
        return $this->moreInfos;
    }

    /**
     * @return string link of calendar entry
     */
    public function getLink(): ?string
    {
        return $this->link;
    }
    
    /**
     * 
     * @return int calendar id this entry is for
     */
    public function getCalendarID(): int
    {
        return $this->calendarID;
    }

    /**
     * @return string name of calendar
     */
    public function getCalendarName(): string
    {
        return $this->calendarName;
    }

    /**
     * 
     * @return array Booking of bookings associated with this calendar entry
     */
    public function getBookings(): ?array
    {
        return $this->bookings;
    }
}