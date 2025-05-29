<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class MeetingNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $meeting;
    public $relatedUserNames;
    public $specialistUserNames;
    public $advisorUserNames;
    public $secretaryUserNames;
    public $decisionMakerName;
    public $customSubject;

    public function __construct($meeting, $customSubject = null)
    {
        $this->meeting = $meeting;
        $this->customSubject = $customSubject;

        $this->relatedUserNames = User::whereIn('id', $meeting->related_users ?? [])->pluck('name')->toArray();
        $this->specialistUserNames = User::whereIn('id', $meeting->specialist_users ?? [])->pluck('name')->toArray();
        $this->advisorUserNames = User::whereIn('id', $meeting->advisor_users ?? [])->pluck('name')->toArray();
        $this->secretaryUserNames = User::whereIn('id', $meeting->secretary_users ?? [])->pluck('name')->toArray();
        $this->decisionMakerName = optional(User::find($meeting->decision_maker_id))->name ?? '(Không rõ)';
    }

    public function build()
    {
        $start = \Carbon\Carbon::parse($this->meeting->start_time)->format('H:i');
        $end = \Carbon\Carbon::parse($this->meeting->end_time)->format('H:i');
        $date = \Carbon\Carbon::parse($this->meeting->date)->format('d/m/Y');

        $subject = $this->customSubject ?: "📅 Mời họp ngày {$date} {$start} - {$end}";

        return $this->subject($subject)
                    ->view('mail.meeting_notification')
                    ->with([
                        'relatedUserNames' => $this->relatedUserNames,
                        'specialistUserNames' => $this->specialistUserNames,
                        'advisorUserNames' => $this->advisorUserNames,
                        'secretaryUserNames' => $this->secretaryUserNames,
                        'decisionMakerName' => $this->decisionMakerName,
                    ]);
    }
}
