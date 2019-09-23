<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VisitTimes
 *
 * @ORM\Table(name="visit_times", indexes={@ORM\Index(name="staff_id", columns={"staff_id"}), @ORM\Index(name="customer_id", columns={"customer_id"})})
 * @ORM\Entity
 */
class VisitTimes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="visit_start_time", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $visitStartTime = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="visit_end_time", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $visitEndTime = 'NULL';

    /**
     * @var int|null
     *
     * @ORM\Column(name="visit_duration", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $visitDuration = 'NULL';

    /**
     * @var \Customers
     *
     * @ORM\ManyToOne(targetEntity="Customers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     * })
     */
    private $customer;

    /**
     * @var \Staff
     *
     * @ORM\ManyToOne(targetEntity="Staff")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="staff_id", referencedColumnName="id")
     * })
     */
    private $staff;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVisitStartTime(): ?\DateTimeInterface
    {
        return $this->visitStartTime;
    }

    public function setVisitStartTime(?\DateTimeInterface $visitStartTime): self
    {
        $this->visitStartTime = $visitStartTime;

        return $this;
    }

    public function getVisitEndTime(): ?\DateTimeInterface
    {
        return $this->visitEndTime;
    }

    public function setVisitEndTime(?\DateTimeInterface $visitEndTime): self
    {
        $this->visitEndTime = $visitEndTime;

        return $this;
    }

    public function getVisitDuration(): ?int
    {
        return $this->visitDuration;
    }

    public function setVisitDuration(?int $visitDuration): self
    {
        $this->visitDuration = $visitDuration;

        return $this;
    }

    public function getCustomer(): ?Customers
    {
        return $this->customer;
    }

    public function setCustomer(?Customers $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getStaff(): ?Staff
    {
        return $this->staff;
    }

    public function setStaff(?Staff $staff): self
    {
        $this->staff = $staff;

        return $this;
    }


}
