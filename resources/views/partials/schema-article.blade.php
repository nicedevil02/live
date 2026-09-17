{{-- اسکیمای استاندارد Article گوگل بدون ریتینگ --}}
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Article",
  "mainEntityOfPage": {
    "@@type": "WebPage",
    "@@id": "{{ $url ?? url()->current() }}"
  },
  "headline": "{{ $headline ?? $title ?? '' }}",
  "description": "{{ $description ?? '' }}",
  "image": [
    "{{ $image ?? asset('images/logo.png') }}"
  ],
  "datePublished": "{{ $datePublished ?? '2025-01-01' }}",
  "dateModified": "{{ $dateModified ?? date('Y-m-d') }}",
  "author": {
    "@@type": "Organization",
    "name": "{{ $author ?? 'تیم تحریریه و کارشناسان طلالایو' }}",
    "url": "https://talalive.ir"
  },
  "publisher": {
    "@@type": "Organization",
    "name": "طلالایو (TalaLive)",
    "logo": {
      "@@type": "ImageObject",
      "url": "https://talalive.ir/images/logo.png"
    }
  }
}
</script>
