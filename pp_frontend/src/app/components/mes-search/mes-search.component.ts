import { Component, Input } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { Recherche } from '../../services/recherche.service';

@Component({
  selector: 'app-mes-search',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './mes-search.component.html',
  styleUrls: ['./mes-search.component.css']
})
export class MesSearchComponent {
  @Input() recherches: Recherche[] = [];
}
