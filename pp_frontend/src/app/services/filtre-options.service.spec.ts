import { TestBed } from '@angular/core/testing';

import { FiltreOptionsService } from './filtre-options.service';

describe('FiltreOptionsService', () => {
  let service: FiltreOptionsService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(FiltreOptionsService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
