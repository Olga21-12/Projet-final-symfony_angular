import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BienCreeComponent } from './bien-cree.component';

describe('BienCreeComponent', () => {
  let component: BienCreeComponent;
  let fixture: ComponentFixture<BienCreeComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [BienCreeComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(BienCreeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
