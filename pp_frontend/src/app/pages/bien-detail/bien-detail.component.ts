import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router, RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import { BienService, Bien } from '../../services/bien.service';
import { HttpClientModule } from '@angular/common/http';

@Component({
  selector: 'app-bien-detail',
  standalone: true,
  imports: [CommonModule, RouterModule, HttpClientModule],
  templateUrl: './bien-detail.component.html',
  styleUrls: ['./bien-detail.component.css']
})
export class BienDetailComponent implements OnInit {
  bien?: Bien;
  loading = true;
  error = '';
  userId: number | null = null;

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private bienService: BienService
  ) {}

  ngOnInit(): void {
    const id = Number(this.route.snapshot.paramMap.get('id'));

    // Vérifions qui est l'auteur (depuis localStorage)
    const storedUser = localStorage.getItem('user');
    if (storedUser) this.userId = JSON.parse(storedUser).id;

    this.bienService.getBienById(id).subscribe({
      next: (res) => {
        this.bien = res;
        this.loading = false;
      },
      error: () => {
        this.error = 'Impossible de charger le logement';
        this.loading = false;
      }
    });
  }

  // Boutons d'action
  editBien(): void {
    if (this.bien) this.router.navigate(['/biens/edit', this.bien.id]);
  }

  goBack(): void {
    this.router.navigate(['/biens']);
  }

  deleteBien(): void {
  if (!this.bien) return;

  const confirmDelete = confirm('Voulez-vous vraiment supprimer ce logement ?');
  if (!confirmDelete) return;

  this.bienService.deleteBien(this.bien.id).subscribe({
    next: (res) => {
      alert(res.message || 'Le logement a été supprimé.');
      this.router.navigate(['/biens']);
    },
    error: (err) => {
      console.error(err);
      if (err.status === 403)
        alert("Vous n'avez pas la permission de supprimer ce logement.");
      else if (err.status === 404)
        alert("Le logement n'existe plus.");
      else
        alert("Erreur lors de la suppression du logement.");
    }
  });
}
}