import { Component, EventEmitter, Output } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-bien-filter',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './bien-filter.component.html',
  styleUrls: ['./bien-filter.component.css']
})
export class BienFilterComponent {

 // @Output() searchChange = new EventEmitter<string>();

//onSearchInput(event: any) {
 // this.searchChange.emit(event.target.value); 
//}

 // filters: any = {};

  
}