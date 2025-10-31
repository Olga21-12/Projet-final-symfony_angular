import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BienFormComponent } from './bien-form.component';

describe('BienFormComponent', () => {
  let component: BienFormComponent;
  let fixture: ComponentFixture<BienFormComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [BienFormComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(BienFormComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});