import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ModalLouerComponent } from './modal-louer.component';

describe('ModalLouerComponent', () => {
  let component: ModalLouerComponent;
  let fixture: ComponentFixture<ModalLouerComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ModalLouerComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ModalLouerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
