import { Component } from '@angular/core';
import { ContactFormComponent } from '../../components/contact-form/contact-form.component';

@Component({
  selector: 'app-contact',
  standalone: true,
  imports: [ContactFormComponent],
  templateUrl: './contact.component.html',
  styleUrl: './contact.component.css'
})
export class ContactComponent {

messageSent = false;

  onSubmit() {
    this.messageSent = true;
    setTimeout(() => (this.messageSent = false), 4000); // исчезнет через 4 секунды
  }
}
