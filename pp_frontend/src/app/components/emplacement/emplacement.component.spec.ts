import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EmplacementComponent } from './emplacement.component';

describe('EmplacementComponent', () => {
  let component: EmplacementComponent;
  let fixture: ComponentFixture<EmplacementComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [EmplacementComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(EmplacementComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
