import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FiltreService } from '../../services/filtre.service';

@Component({
  selector: 'app-bien',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './bien.component.html',
  styleUrl: './bien.component.css'
})
export class BienComponent implements OnInit {

  biens: any[] = []; 
  loading = false;   

  constructor(private filtreService: FiltreService) {}

  ngOnInit(): void {
    
    this.loadAllBiens();
  }

  loadAllBiens() {
    this.loading = true;
    this.filtreService.search({}).subscribe({
      next: (data) => {
        this.biens = data;
        this.loading = false;
      },
      error: (err) => {
        console.error('Erreur lors du chargement des biens:', err);
        this.loading = false;
      }
    });
  }

  // 
  onSearch(filters: any) {
    this.loading = true;
    this.filtreService.search(filters).subscribe({
      next: (data) => {
        this.biens = data;
        this.loading = false;
      },
      error: (err) => {
        console.error('Erreur de filtrage:', err);
        this.loading = false;
      }
    });
  }
}
