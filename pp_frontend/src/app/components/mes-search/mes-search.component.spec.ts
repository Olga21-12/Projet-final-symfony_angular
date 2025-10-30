import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MesSearchComponent } from './mes-search.component';

describe('MesSearchComponent', () => {
  let component: MesSearchComponent;
  let fixture: ComponentFixture<MesSearchComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [MesSearchComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MesSearchComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
