#!/usr/bin/python3

import cv2
from pyzbar.pyzbar import decode

from picamera2 import MappedArray, Picamera2, Preview
colour = (0, 255, 0)
font = cv2.FONT_HERSHEY_SIMPLEX
scale = 1
thickness = 2
def scan_barcode():
    picam2 = Picamera2()
    # picam2.start_preview(Preview.QTGL)
    # config = picam2.create_preview_configuration(main={"size": (1280, 960)})
    # picam2.configure(config)
    # picam2.post_callback = draw_barcodes
    picam2.start()
    while True:
        rgb = picam2.capture_array("main")
        barcodes = decode(rgb)
        if barcodes:
            for b in barcodes:
                print(b.data)
                picam2.stop()
                picam2.stop_preview()
                picam2.close()
                return b.data


def draw_barcodes(request):
    with MappedArray(request, "main") as m:
        for b in barcodes:
            if b.polygon:
                x = min([p.x for p in b.polygon])
                y = min([p.y for p in b.polygon]) - 30
                cv2.putText(m.array, b.data.decode('utf-8'), (x, y), font, scale, colour, thickness)


barcodes = []
