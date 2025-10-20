import { CommonModule } from '@angular/common';
import { Component, Output, EventEmitter } from '@angular/core';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-contact-form',
  standalone: true,
  imports: [CommonModule, FormsModule], // FormsModule permet d’utiliser les directives d’Angular pour les formulaires
  templateUrl: './contact-form.component.html',
  styleUrl: './contact-form.component.css'
})
export class ContactFormComponent {
  messageSent = false;

  // 📬 Méthode déclenchée lors du clic sur "Envoyer"
  onSubmit() {
    this.messageSent = true;

  // 🔹 Le message disparaît automatiquement après 4 secondes
    setTimeout(() => (this.messageSent = false), 4000);
  }
}
