import { Pipe, PipeTransform } from '@angular/core';
import { DomSanitizer, SafeHtml } from '@angular/platform-browser';

@Pipe({
  name: 'truncate'
})
export class TruncatePipe implements PipeTransform {

  constructor(private sanitizer: DomSanitizer) {}

  transform(value: string, limit: number = 100, completeWords: boolean = true, ellipsis: string = '...', asHtml: boolean = false): string | SafeHtml {

    if (!value) return '';
    if (value.length <= limit) return asHtml ? this.sanitizer.bypassSecurityTrustHtml(value) : value;

    let truncated = value.substr(0, limit);

    if (completeWords) {
      const lastSpace = truncated.lastIndexOf(' ');
      if (lastSpace > 0) {
        truncated = truncated.substr(0, lastSpace);
      }
    }
    const result = truncated + ellipsis;

  return asHtml ? this.sanitizer.bypassSecurityTrustHtml(result) : result;
  }
}
