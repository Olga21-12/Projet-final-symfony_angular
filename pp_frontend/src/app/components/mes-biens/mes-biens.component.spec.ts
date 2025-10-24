import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MesBiensComponent } from './mes-biens.component';

describe('MesBiensComponent', () => {
  let component: MesBiensComponent;
  let fixture: ComponentFixture<MesBiensComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [MesBiensComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MesBiensComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
