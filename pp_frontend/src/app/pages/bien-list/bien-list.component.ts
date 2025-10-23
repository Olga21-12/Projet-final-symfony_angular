import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { BienService, Bien } from '../../services/bien.service';
import { HttpClientModule } from '@angular/common/http';
import { TruncatePipe } from '../../pipes/truncate.pipe';

@Component({
  selector: 'app-bien-list',
  standalone: true,
  imports: [CommonModule, RouterModule, HttpClientModule, TruncatePipe],
  templateUrl: './bien-list.component.html',
  styleUrls: ['./bien-list.component.css']
})
export class BienListComponent implements OnInit {
  biens: Bien[] = [];
  loading = true;
  error = '';
  totalBiens = 0;

  constructor(private bienService: BienService) {}

  ngOnInit(): void {
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
}