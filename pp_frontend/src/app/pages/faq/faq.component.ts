import { Component } from '@angular/core';
import { ContactComponent } from '../contact/contact.component';
import { ContactFormComponent } from "../../components/contact-form/contact-form.component";

@Component({
  selector: 'app-faq',
  standalone: true,
  imports: [ContactComponent, ContactFormComponent],
  templateUrl: './faq.component.html',
  styleUrl: './faq.component.css'
})
export class FaqComponent {

}
