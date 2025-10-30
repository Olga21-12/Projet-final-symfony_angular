import { Component, Input, Output, EventEmitter } from '@angular/core';
import { CommonModule } from '@angular/common';
import { BienService } from '../../services/bien.service';

@Component({
  selector: 'app-modal-louer',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './modal-louer.component.html',
  styleUrls: ['./modal-louer.component.css']
})
export class ModalLouerComponent {
  @Input() bienId!: number;             
  @Input() visible = false;             
  @Output() closed = new EventEmitter<void>();
  @Output() success = new EventEmitter<void>();
  @Input() userId!: number;

  loading = false;

  durations = [
    { days: 1,  label: '1 jour' },
    { days: 3,  label: '3 jours' },
    { days: 5,  label: '5 jours' },
    { days: 7,  label: '1 semaine' },
    { days: 14, label: '2 semaines' },
    { days: 21, label: '3 semaines' },
    { days: 30, label: '1 mois' },
  ];

  constructor(private bienService: BienService) {}

  close(): void {
    this.closed.emit();
  }

  chooseDuration(durationDays: number): void {
    if (this.loading || !this.bienId) return;
    this.loading = true;

    this.bienService.shortRent(this.bienId, durationDays, this.userId).subscribe({
      next: (res) => {
        alert(res.message || 'Réservation confirmée ✅');
        this.loading = false;
        this.success.emit();  
        this.close();
      },
      error: (err) => {
        console.error(err);
        alert(err.error?.message || 'Erreur lors de la réservation ❌');
        this.loading = false;
      }
    });
  }
}
