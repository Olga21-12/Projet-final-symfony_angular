import { CommonModule } from '@angular/common';
import { Component, Output, EventEmitter } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { ContactService } from '../../services/contact.service';

@Component({
  selector: 'app-contact-form',
  standalone: true,
  imports: [CommonModule, FormsModule], // FormsModule permet d’utiliser les directives d’Angular pour les formulaires
  templateUrl: './contact-form.component.html',
  styleUrl: './contact-form.component.css'
})
export class ContactFormComponent {
  messageSent = false;
  contact = { name: '', email: '', message: '' };

  constructor(private contactService: ContactService) {}

  // 📬 Méthode déclenchée lors du clic sur "Envoyer"
  onSubmit() {
    if (!this.contact.name || !this.contact.email || !this.contact.message) {
      console.log(this.contact);
      alert('Veuillez remplir tous les champs.');
      return;
    }

    this.contactService.sendMessage(this.contact).subscribe({
      next: () => {
        this.messageSent = true;
        this.contact = { name: '', email: '', message: '' }; // очистка полей
        setTimeout(() => (this.messageSent = false), 3000);
      },
      error: (err) => {
        console.error('Erreur lors de l’envoi:', err);
        alert('Une erreur est survenue.');
      },
    });
  }
}
