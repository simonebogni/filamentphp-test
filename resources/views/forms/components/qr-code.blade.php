<script type="text/javascript" src="https://unpkg.com/qr-code-styling@1.5.0/lib/qr-code-styling.js"></script>
<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>

    @php
        $imageUrl = $getImageUrl();
    @endphp
    <div
        x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }"
        x-init="
            const options = {
                width: {{ $getSize() }},
                height: {{ $getSize() }},
                type: 'svg',
                data: '{{$getRecord()->email}}',
                @if($imageUrl)
                    image: @js($imageUrl),
                    imageOptions: {
                        hideBackgroundDots: true,
                        imageSize: 50,
                        margin: 20,
                        crossOrigin: 'anonymous',
                    },
                @endif
                qrOptions: {
                    typeNumber: 0,
                    mode: 'Byte',
                    errorCorrectionLevel: 'H'
                },
                dotsOptions: {
                    color: '#4267b2',
                    type: 'dots'
                },
                cornersSquareOptions: {
                    color: '#4267b2',
                    type: 'dot',
                    // gradient: {
                    //   type: 'linear', // 'radial'
                    //   rotation: 180,
                    //   colorStops: [{ offset: 0, color: '#25456e' }, { offset: 1, color: '#4267b2' }]
                    // },
                },
                cornersDotOptions: {
                    color: '#4267b2',
                    type: 'dot',
                    // gradient: {
                    //   type: 'linear', // 'radial'
                    //   rotation: 180,
                    //   colorStops: [{ offset: 0, color: '#00266e' }, { offset: 1, color: '#4060b3' }]
                    // },
                }
{{--                backgroundOptions: {--}}
{{--                    color: '#e9ebee',--}}
{{--                },--}}
            }
            const qrCode = new QRCodeStyling(options);
            qrCode.append($refs.canvas);
        "
    >
        <div id="qr" x-ref="canvas"></div>
    </div>
</x-dynamic-component>
