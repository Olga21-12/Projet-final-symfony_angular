import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { BienFormComponent } from '../../components/bien-form/bien-form.component';

@Component({
  selector: 'app-bien-cree',
  standalone: true,
  imports: [CommonModule, BienFormComponent],
  templateUrl: './bien-cree.component.html',
})
export class BienCreeComponent {}