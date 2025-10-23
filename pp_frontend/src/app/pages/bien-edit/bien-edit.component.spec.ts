import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BienEditComponent } from './bien-edit.component';

describe('BienEditComponent', () => {
  let component: BienEditComponent;
  let fixture: ComponentFixture<BienEditComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [BienEditComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(BienEditComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
