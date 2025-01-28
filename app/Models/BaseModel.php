<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BaseModel extends Model implements HasMedia
{
    // Uses
    use HasFactory, Notifiable, InteractsWithMedia;

    // =================================== Scopes ================================= //
    /**
     * Scope a query to only include branches.
     */
    public function scopeBranchScope(Builder $query, $request): void
    {
        $conditions = [['branch_id', $request->branch_id], ['nursery_id', $request->nursery_id],];
        if ($request->has('class_room_id')) {
            $conditions[] = ['class_room_id', $request->class_room_id];
        }
        $query->orWhere($conditions);
    }

    /**
     * Scope a query to only include class.
     */
    public function scopeClassScope(Builder $query, $request): void
    {
        $query->where('class_room_id', $request->class_room_id);
    }

    /**
     * Scope a query to only include class.
     */
    public function scopeDateScope(Builder $query, $request): void
    {
        $date = Carbon::parse($request->date);
        $query->whereDate('created_at', $date);
    }

    /**
     * Scope a query to only include class.
     */
    public function scopeAttendanceDateScope(Builder $query, $request): void
    {
        $date = Carbon::parse($request->date);
        $query->whereDate('date', $date);
    }

    /**
     * Scope a query to only include class.
     */
    public function scopeKidScope(Builder $query, $request): void
    {
        $query->where('kid_id', $request->kid_id);
    }

    /**
     * Scope a query to only include class.
     */
    public function scopeNurseryScope(Builder $query, $request): void
    {
        $query->where('nursery_id', $request->nursery_id);
    }
  
}
