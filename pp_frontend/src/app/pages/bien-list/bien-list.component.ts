import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router, RouterModule } from '@angular/router';
import { BienService, Bien } from '../../services/bien.service';
import { TruncatePipe } from '../../pipes/truncate.pipe';

@Component({
  selector: 'app-bien-list',
  standalone: true,
  imports: [CommonModule, RouterModule, TruncatePipe],
  templateUrl: './bien-list.component.html',
  styleUrls: ['./bien-list.component.css']
})
export class BienListComponent implements OnInit {
  biens: Bien[] = [];
  loading = true;
  error = '';
  totalBiens = 0;

  user: any = null;

  constructor(private bienService: BienService,
              private router: Router) {}

  ngOnInit(): void {
      // Vérifiez s'il y a un utilisateur connecté
    const storedUser = localStorage.getItem('user');
      if (storedUser) {
        this.user = JSON.parse(storedUser);
      }

      //Logement de chargement
    this.bienService.getAllBiens().subscribe({
      next: (res) => {
        this.biens = res;
        this.loading = false;
      },
      error: (err) => {
        this.error = 'Erreur de chargement des biens';
        this.loading = false;
      }
    });

    // Chargement de la quantité totale
    this.bienService.getTotalBiens().subscribe({
      next: (count) => this.totalBiens = count,
      error: () => this.totalBiens = 0
    });
  }

  // Méthode en cliquant sur « Voir plus »
  voirBien(bienId: number): void {
    if (!this.user) {
      // Si l'utilisateur est un invité, nous l'envoyons à la connexion
      alert('Pour voir le détail, veuillez vous connecter ou vous inscrire.');
      this.router.navigate(['/login']);
      return;
    }

    // Si l'utilisateur existe, ouvrez la carte
    this.router.navigate(['/biens', bienId]);
  }

}