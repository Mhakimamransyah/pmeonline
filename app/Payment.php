<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    const STATE_WAITING = 'waiting';

    const STATE_VERIFIED = 'verified';

    const STATE_REJECTED = 'rejected';

    const STATE_DEBT = 'debt';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Set this payment's evidence. Link to file storage.
     *
     * @param string $evidence
     * @return $this
     */
    public function setEvidence(string $evidence)
    {
        $this->evidence = $evidence;
        return $this;
    }

    /**
     * Set this payment's note from participant.
     *
     * @param string|null $note
     * @return $this
     */
    public function setNoteFromParticipant(?string $note)
    {
        $this->note_from_participant = $note;
        return $this;
    }

    /**
     * Set this payment's note from administrator.
     *
     * @param string|null $note
     * @return $this
     */
    public function setNoteFromAdministrator(?string $note)
    {
        $this->note_from_administrator = $note;
        return $this;
    }

    /**
     * Set this payment's state. Must be one of following STATE_WAITING, STATE_VERIFIED, STATE_REJECTED, STATE_DEBT.
     *
     * @param string $state
     * @return $this
     */
    public function setState(string $state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * Set this payment's invoice.
     *
     * @param Invoice $invoice
     * @return $this
     */
    public function setInvoice(Invoice $invoice)
    {
        $this->invoice()->associate($invoice);
        return $this;
    }

    /**
     * Relationship between Payment and Invoice.
     *
     * @return BelongsTo
     */
    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

    /**
     * Return this payment's id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return this payment's evidence.
     *
     * @return string
     */
    public function getEvidence()
    {
        return $this->evidence;
    }

    /**
     * Return this payment's evidence storage link.
     *
     * @return string
     */
    public function getEvidenceStorageLink()
    {
        return asset('storage/' . str_replace('public/', '', $this->getEvidence()));
    }

    /**
     * Return this payment's note from participant.
     *
     * @return string|null
     */
    public function getNoteFromParticipant()
    {
        return $this->note_from_participant;
    }

    /**
     * Return this payment's note from administrator.
     *
     * @return string
     */
    public function getNoteFromAdministrator()
    {
        return $this->note_from_administrator;
    }

    /**
     * Return this payment's state.
     * Value should be one of STATE_WAITING, STATE_VERIFIED, STATE_REJECTED, STATE_DEBT
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    public function getStateLabel()
    {
        if ($this->getState() == self::STATE_WAITING) {
            return 'Menunggu Konfirmasi';
        }
        if ($this->getState() == self::STATE_VERIFIED) {
            return 'Terverifikasi';
        }
        if ($this->getState() == self::STATE_REJECTED) {
            return 'Ditolak';
        }
        if ($this->getState() == self::STATE_DEBT) {
            return 'Terhutang';
        }
        return 'Tak Terdefinisi';
    }

    /**
     * Return this payment's invoice.
     *
     * @return Invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * Return true if this payment is waiting for verification.
     *
     * @return bool
     */
    public function isWaitingVerification()
    {
        return $this->getState() == Payment::STATE_WAITING;
    }

    /**
     * Return true if this payment is verified.
     *
     * @return bool
     */
    public function isVerified()
    {
        return $this->getState() == Payment::STATE_VERIFIED;
    }

    /**
     * Return true if this payment is rejected.
     *
     * @return bool
     */
    public function isRejected()
    {
        return $this->getState() == Payment::STATE_REJECTED;
    }

    /**
     * Return true if this payment is in debt.
     *
     * @return bool
     */
    public function isInDebt()
    {
        return $this->getState() == Payment::STATE_DEBT;
    }
}
