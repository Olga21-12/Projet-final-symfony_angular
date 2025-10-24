import { Component, Input, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { BienService } from '../../services/bien.service';
import { RouterModule } from '@angular/router';
import { Router } from '@angular/router';

@Component({
  selector: 'app-mes-biens',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './mes-biens.component.html',
  styleUrls: ['./mes-biens.component.css']
})
export class MesBiensComponent implements OnInit {
  @Input() userId!: number;
  biens: any[] = [];
  loading = true;

  constructor(private bienService: BienService, private router: Router) {}

  ngOnInit(): void {
    this.bienService.getBiensByUserId(this.userId).subscribe({
      next: (data) => {
        console.log('📦 Biens reçus:', data);
        this.biens = data;
        this.loading = false;
      },
      error: (err) => {
        console.error('Erreur chargement annonces:', err);
        this.loading = false;
      },
    });
  }

  viewBien(id: number) {
    this.router.navigate(['/biens', id]);
  }

  editBien(id: number) {
    this.router.navigate(['/biens', id, 'edit']);
  }

  deleteBien(id: number) {
    if (!id) {
      console.warn('⚠️ ID manquant pour suppression');
      console.log('🗑️ deleteBien id =', id);
      return;
    }
    if (confirm('Voulez-vous vraiment supprimer ce bien ?')) {
      this.bienService.deleteBien(id).subscribe({
        next: () => {
          alert('Bien supprimé avec succès.');
          this.biens = this.biens.filter(b => b.id !== id);
        },
        error: (err) => {
          console.error('Erreur suppression bien:', err);
          alert("Une erreur est survenue lors de la suppression.");
        },
      });
    }
  }
}
