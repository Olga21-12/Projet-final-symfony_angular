import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BienFiltreComponent } from './bien-filtre.component';

describe('BienFiltreComponent', () => {
  let component: BienFiltreComponent;
  let fixture: ComponentFixture<BienFiltreComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [BienFiltreComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(BienFiltreComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
