import { Component, EventEmitter, OnInit, Output } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { FiltreOptionsService } from '../../services/filtre-options.service';

@Component({
  selector: 'app-bien-filtre',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './bien-filtre.component.html',
  styleUrl: './bien-filtre.component.css'
})
export class BienFiltreComponent implements OnInit {
  @Output() search = new EventEmitter<any>();

  filters = {
    q: '',
    pays: '',
    ville: '',
    prixMax: '',
    surfaceMax: '',
    chambres: '',
    confort: '',     
    typeBien: '',
    activite: ''   
  };

  paysList: string[] = [];
  villesList: string[] = [];
  confortsList: string[] = [];
  typesList: string[] = [];
  activitesList: string[] = [];

  constructor(private optionsService: FiltreOptionsService) {}

  ngOnInit(): void {
    this.optionsService.getOptions().subscribe({
      next: (res) => {
        this.paysList = res.pays.sort((a: string, b: string) => a.localeCompare(b));
        this.villesList = res.villes.sort((a: string, b: string) => a.localeCompare(b));
        this.typesList = res.types.sort((a: string, b: string) => a.localeCompare(b));
        this.activitesList = res.activites;
        this.confortsList = res.conforts.sort((a: string, b: string) => a.localeCompare(b));
      },
      error: (err) => console.error('Erreur chargement des options', err)
    });
  }

  toggleSelection(array: string[], value: string) {
    const index = array.indexOf(value);
    if (index === -1) array.push(value);
    else array.splice(index, 1);
  }

  onSubmit() {
    this.search.emit(this.filters);
  }

  openSection: string | null = null;

    toggleSection(section: string) {
      this.openSection = this.openSection === section ? null : section;
    }
}
