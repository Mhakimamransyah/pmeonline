<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submit extends Model
{
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'sent' => 'boolean',
        'verified' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Set this submit's order.
     *
     * @param Order $order
     * @return $this
     */
    public function setOrder(Order $order)
    {
        $this->order()->associate($order);
        return $this;
    }

    /**
     * Set this submit's value.
     *
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Set this submit's sent status.
     *
     * @param bool $sent
     * @return $this
     */
    public function setSent(bool $sent)
    {
        $this->sent = $sent;
        return $this;
    }

    /**
     * Set this submit's verified status.
     *
     * @param bool $verified
     * @return $this
     */
    public function setVerified(bool $verified)
    {
        $this->verified = $verified;
        return $this;
    }

    /**
     * Return this submit's id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return this submit's order.
     *
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Return this submit's value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Return this submit's sent status.
     *
     * @return boolean
     */
    public function isSent()
    {
        return $this->sent;
    }

    /**
     * Return this submit's verified status.
     *
     * @return boolean
     */
    public function isVerified()
    {
        return $this->verified;
    }

    /**
     * Return this submit's updated at.
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return Carbon::parse($this->updated_at)->locale('id')->diffForHumans();
    }

    /**
     * Relationship between Submit and Order.
     *
     * @return BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function getScoreAttribute()
    {
        return $this->order->score;
    }

    public function getLaboratoryNameAttribute()
    {
        try {
            return $this->order->invoice->laboratory->name;
        } catch (\Exception $e) {
            return '-';
        }
    }

    public function getLaboratoryProvinceAttribute()
    {
        try {
            return $this->order->invoice->laboratory->province->name;
        } catch (\Exception $e) {
            return '-';
        }
    }

    public function getParticipantNumberAttribute()
    {
        try {
            return $this->order->invoice->laboratory->participant_number;
        } catch (\Exception $e) {
            return '-';
        }
    }

    public function getContactPersonNameAttribute()
    {
        try {
            return $this->order->invoice->laboratory->user->name;
        } catch (\Exception $e) {
            return '-';
        }
    }

    public function getSelectedParametersAttribute()
    {
        $scoring_method = $this->order->package->scoring_method;
        if ($scoring_method == 'sipilis') {
            if ($this->score == null || $this->score->value == null) {
                return [];
            }
            $parameters = [];
            $tphaScores = [];
            $rprScores = [];
            $scoreValue = json_decode($this->score->value);
            foreach ($scoreValue->tpha->score as $score) {
                if ($score != null) {
                    array_push($tphaScores, $score);
                }
            }
            if (count($tphaScores) > 0) {
                array_push($parameters, 'TPHA');
            }
            foreach ($scoreValue->rpr->score as $score) {
                if ($score != null) {
                    array_push($rprScores, $score);
                }
            }
            if (count($rprScores) > 0) {
                array_push($parameters, 'RPR');
            }
            return $parameters;
        }
        if ($scoring_method == 'kimia-klinik-2019') {
            $scoreValue = json_decode($this->value);
            $parameterCount = count($this->order->package->parameters);
            $ids = [];
            for ($i = 0; $i < $parameterCount; $i++) {
                if (isset($scoreValue->{'hasil_'.$i.'_1'}) && $scoreValue->{'hasil_'.$i.'_1'} != null) {
                    array_push($ids, $i);
                }
            }
            $parameters = [];
            foreach ($ids as $id) {
                array_push($parameters, $scoreValue->{'parameter_name_'.$id});
            }
            return $parameters;
        }
        if ($scoring_method == 'hematologi-2019') {
            $scoreValue = json_decode($this->value);
            $parameterCount = count($this->order->package->parameters);
            $ids = [];
            for ($i = 0; $i < $parameterCount; $i++) {
                if (isset($scoreValue->{'hasil_'.$i.'_bottle_1'}) && $scoreValue->{'hasil_'.$i.'_bottle_1'} != null) {
                    array_push($ids, $i);
                }
            }
            $parameters = [];
            foreach ($ids as $id) {
                array_push($parameters, $scoreValue->{'parameter_name_'.$id});
            }
            return $parameters;
        }
        if ($scoring_method == 'urinalisa-2019') {
            $scoreValue = json_decode($this->value);
            $parameterCount = count($this->order->package->parameters);
            $ids = [];
            for ($i = 0; $i < $parameterCount; $i++) {
                if (isset($scoreValue->{'hasil_pemeriksaan_'.$i.'_bottle_1'}) && $scoreValue->{'hasil_pemeriksaan_'.$i.'_bottle_1'} != null) {
                    array_push($ids, $i);
                }
            }
            $parameters = [];
            foreach ($ids as $id) {
                array_push($parameters, $scoreValue->{'parameter_'.$id});
            }
            return $parameters;
        }
        if ($scoring_method == 'hemostasis-2019') {
            $scoreValue = json_decode($this->value);
            $parameters = [];
            $count = 0;
            foreach ($this->order->package->parameters as $parameter) {
                if (isset($scoreValue->{'hasil_'.$count.'_bottle_1'}) && $scoreValue->{'hasil_'.$count.'_bottle_1'} != null) {
                    array_push($parameters, $parameter->label);
                }
                $count += 1;
            }
            return $parameters;
        }
        if ($scoring_method == 'kimia-air-2019') {
            $scoreValue = json_decode($this->value);
            $parameters = [];
            foreach ($this->order->package->parameters as $parameter) {
                if (isset($scoreValue->{'hasil_pengujian_'.$parameter->label}) && $scoreValue->{'hasil_pengujian_'.$parameter->label} != null) {
                    array_push($parameters, $parameter->label);
                }
            }
            return $parameters;
        }
        $parameters = $this->order->package->parameters->map(function (Parameter $parameter) {
            return $parameter->label;
        })->toArray();
        return $parameters;
    }
}
