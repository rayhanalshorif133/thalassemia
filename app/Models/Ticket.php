<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ticket_series_id',
        'ticket_no',
        'reference_no',
        'sold_status',
        'sold_date',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sold_date' => 'datetime',
        'sold_status' => 'integer',
        'reference_no' => 'integer',
    ];

    /**
     * Get the user who created the ticket.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the ticket.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope a query to only include sold tickets.
     */
    public function scopeSold($query)
    {
        return $query->where('sold_status', 1);
    }

    /**
     * Scope a query to only include unsold tickets.
     */
    public function scopeUnsold($query)
    {
        return $query->where('sold_status', 0);
    }

    /**
     * Get the status label.
     */
    public function getStatusLabelAttribute()
    {
        return $this->sold_status == 1 ? 'Sold' : 'Unsold';
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeAttribute()
    {
        return $this->sold_status == 1 ? 'bg-success' : 'bg-warning';
    }
}
