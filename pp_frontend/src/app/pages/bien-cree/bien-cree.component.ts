import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router } from '@angular/router';
import { BienService } from '../../services/bien.service';
import { BienFormComponent } from '../../components/bien-form/bien-form.component';

@Component({
  selector: 'app-bien-cree',
  standalone: true,
  imports: [CommonModule, BienFormComponent],
  templateUrl: './bien-cree.component.html',
})
export class BienCreeComponent {
  message = '';
  error = '';

  constructor(private bienService: BienService, private router: Router) {}

  onFormSubmit(event: { payload: any; photos: File[] }): void {
  this.error = '';
  this.message = '';

  this.bienService.createBien(event.payload, event.photos).subscribe({
    next: (res) => {
      this.message = res.message || 'Bien ajouté avec succès ✅';
      setTimeout(() => {
        this.router.navigate(['/biens']);
      }, 2000);
    },
    error: (err) => {
      console.error('Erreur création bien:', err);
      this.error = err.error?.error || 'Erreur lors de l’ajout du bien.';
    }
  });
}

goBack(): void {
    this.router.navigate([`/biens`]);
  }
  
}
