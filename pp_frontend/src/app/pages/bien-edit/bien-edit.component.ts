import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, Router } from '@angular/router';
import { BienFormComponent } from '../../components/bien-form/bien-form.component';
import { BienService } from '../../services/bien.service';

@Component({
  selector: 'app-bien-edit',
  standalone: true,
  imports: [CommonModule, BienFormComponent],
  templateUrl: './bien-edit.component.html',
})
export class BienEditComponent implements OnInit {
  bienData: any = null;
  bienId!: number;
  message = '';
  error = '';

  constructor(private route: ActivatedRoute, private bienService: BienService, private router: Router) {}

  ngOnInit(): void {
    const id = Number(this.route.snapshot.paramMap.get('id'));
    if (id) {
      this.bienService.getBienById(id).subscribe({
        next: (res) => (this.bienData = res),
        error: (err) => console.error('Erreur chargement bien', err),
      });
    }
  }

  onFormSubmit(event: { payload: any; photos: File[] }): void {
    this.error = '';
    this.message = '';

    if (!this.bienData?.id) {
      this.error = 'Aucun identifiant de logement trouvé.';
      return;
    }

    this.bienService.updateBien(this.bienData.id, event.payload, event.photos).subscribe({
      next: (res) => {
        this.message = res.message || 'Bien mis à jour avec succès ✅';
        setTimeout(() => this.router.navigate(['/biens']), 1500);
      },
      error: (err) => {
        console.error('Erreur lors de la mise à jour du bien:', err);
        this.error = err.error?.error || 'Erreur lors de la mise à jour.';
      }
    });
  }

  goBack(): void {
    this.router.navigate([`/biens`]);
  }

  
}