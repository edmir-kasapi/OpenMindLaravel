<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ForgotPasswordNotification;
use App\Notifications\VerificationReminder;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

//#[Fillable(['name', 'email', 'password', 'role_id'])]
//#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, Billable, HasApiTokens;

    protected $fillable = ['name', 'email', 'password', 'role_id'];
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hasRole(array $roles)
    {
        return in_array($this->role->getRoleName(), $roles);
    }

    public function isVerified(): bool
    {
        if(!isset($this->email_verified_at))
        {
            return false;
        }

        return true;
    }

    public function getVerificationStatus()
    {
        return $this->isVerified() ? 'Verified' : 'Unverified';
    }

    public function getVerificationDate()
    {
        return $this->isVerified() ? Carbon::parse($this->email_verified_at)->format('H:i:s d-m-Y') : '';
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ForgotPasswordNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification());
    }

    public function sendVerificationReminderNotification()
    {
        $this->notify(new VerificationReminder($this));
    }

    #[Scope]
    protected function searchName(Builder $query, ?string $name)
    {
        $query->when($name, function ($query) use ($name) {
            return $query->where('name', 'LIKE', "%".$name."%");
        });
    }

    #[Scope]
    protected function searchEmail(Builder $query, ?string $email)
    {
        $query->when($email, function ($query) use ($email){
            return $query->where('email', 'LIKE', "%".$email."%");
        });
    }

    #[Scope]
    protected function searchRole(Builder $query, ?string $role_id)
    {
        $query->when($role_id, function ($query) use ($role_id) {
            return $query -> where('role_id', $role_id);
        });

        return $query;
    }

    #[Scope]
    protected function verified(Builder $query)
    {
        return $query -> where('email_verified_at', '!=', null);
    }

    #[Scope]
    protected function unverified(Builder $query)
    {
        return $query -> where('email_verified_at', null);
    }

    #[Scope]
    protected function filterStatus(Builder $query, ?string $status)
    {
        match($status)
        {
            'verified'   => $query->verified(),
            'unverified' => $query->unverified(),
            default      => null
        };
    }

    #[Scope]
    protected function sortBy(Builder $query, ?string $sort_type)
    {
        match ($sort_type)
        {
            'name-asc'  => $query -> orderBy('name') -> orderBy('id'),
            'name-desc' => $query -> orderByDesc('name') -> orderByDesc('id'),
            'email-asc' => $query -> orderBy('email') -> orderBy('id'),
            'email-desc'=> $query -> orderByDesc('email') -> orderByDesc('id'),
            'role-asc'  => $query -> orderBy('role_id') -> orderBy('id'),
            'role-desc' => $query -> orderByDesc('role_id') -> orderByDesc('id'),
            'date-asc'  => $query -> oldest('created_at') -> orderBy('id'),
            'date-desc' => $query -> latest('created_at') -> orderByDesc('id'),
            default     => $query -> latest('created_at') -> orderByDesc('id')
        };
    }

    #[Scope]
    protected function today(Builder $query)
    {
        return $query->whereDay('created_at', now()->day)
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->get();
    }

    #[Scope]
    protected function thisMonth(Builder $query)
    {
        return $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->get();
    }

    #[Scope]
    protected function thisYear(Builder $query)
    {
        return $query->whereYear('created_at', now()->year)
                    ->get();
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function profile()
    {
        return $this->hasOne(ProfilePhoto::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
