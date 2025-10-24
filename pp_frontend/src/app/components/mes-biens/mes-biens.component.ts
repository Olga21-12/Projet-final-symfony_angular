import { Component, Input, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { BienService } from '../../services/bien.service';
import { RouterModule } from '@angular/router';

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

  constructor(private bienService: BienService) {}

  ngOnInit(): void {
    this.bienService.getBiensByUserId(this.userId).subscribe({
      next: (data) => {
        this.biens = data;
        this.loading = false;
      },
      error: (err) => {
        console.error('Erreur chargement annonces:', err);
        this.loading = false;
      },
    });
  }
}
