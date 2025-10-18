import { Component, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-contact-form',
  standalone: true,
  templateUrl: './contact-form.component.html',
  styleUrl: './contact-form.component.css'
})
export class ContactFormComponent {
  @Output() formSubmitted = new EventEmitter<void>();

  onSubmit() {
    this.formSubmitted.emit();
  }
}
