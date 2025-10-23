import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BienFilterComponent } from './bien-filter.component';

describe('BienFilterComponent', () => {
  let component: BienFilterComponent;
  let fixture: ComponentFixture<BienFilterComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [BienFilterComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(BienFilterComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
