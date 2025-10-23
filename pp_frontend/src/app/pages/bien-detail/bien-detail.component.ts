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

  deleteBien(): void {
    if (!confirm('Supprimer ce logement ?')) return;
    alert('Suppression simulée ici. (À implémenter ensuite)');
  }

  goBack(): void {
    this.router.navigate(['/biens']);
  }
}