<?php

namespace App\Mail;

use App\Models\Facture;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FactureEnvoyee extends Mailable
{
    use Queueable, SerializesModels;

    public $facture;

    public function __construct(Facture $facture)
    {
        $this->facture = $facture;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Facture #{$this->facture->id} - InvoFlex"
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.facture'
        );
    }

    public function attachments(): array
    {
        // Générer le PDF temporaire
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            $this->facture->template?->chemin_blade ?? 'factures.templates.standard',
            ['facture' => $this->facture->load('user.emetteur')]
        );

        return [
            \Illuminate\Mail\Mailables\Attachment::fromData(fn () => $pdf->output(), "facture_{$this->facture->id}.pdf")
                ->withMime('application/pdf'),
        ];
    }
}