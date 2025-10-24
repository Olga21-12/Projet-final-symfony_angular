import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute } from '@angular/router';
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

  constructor(private route: ActivatedRoute, private bienService: BienService) {}

  ngOnInit(): void {
    const id = Number(this.route.snapshot.paramMap.get('id'));
    if (id) {
      this.bienService.getBienById(id).subscribe({
        next: (res) => (this.bienData = res),
        error: (err) => console.error('Erreur chargement bien', err),
      });
    }
  }

  
}