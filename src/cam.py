import cv2
from pyzbar.pyzbar import decode


def scan_qr():
    # set up camera object
    cap = cv2.VideoCapture(0)

    # QR code detection object
    detector = cv2.QRCodeDetector()

    while True:
        # get the image
        _, img = cap.read()
        # get bounding box coords and data
        data, bbox, _ = detector.detectAndDecode(img)
        
        # if there is a bounding box, draw one, along with the data
        if(bbox is not None):
            for i in range(len(bbox)):
                cv2.line(img, tuple(bbox[i][0]), tuple(bbox[(i+1) % len(bbox)][0]), color=(255,
                        0, 255), thickness=2)
            cv2.putText(img, data, (int(bbox[0][0][0]), int(bbox[0][0][1]) - 10), cv2.FONT_HERSHEY_SIMPLEX,
                        0.5, (0, 255, 0), 2)
            if data:
                print("data found: ", data)
                return data
        # display the image preview
        cv2.imshow("code detector", img)
        if(cv2.waitKey(1) == ord("q")):
            break
    # free camera object and exit
    cap.release()
    cv2.destroyAllWindows()


def BarcodeReader(image):
    img = cv2.imread(image)
    detectedBarcodes = decode(img)

    min_width = 10  # Minimum width threshold for barcode region
    min_height = 10  # Minimum height threshold for barcode region
    
    if not detectedBarcodes:
        print("Barcode Not Detected or your barcode is blank/corrupted!")
    else:
        for barcode in detectedBarcodes:
            (x, y, w, h) = barcode.rect
            
            if w > min_width and h > min_height:
                cv2.rectangle(img, (x-10, y-10), (x + w+10, y + h+10), (255, 0, 0), 2)
                if barcode.data != "":
                    print(barcode.data)
                    print(barcode.type)

    # Save the image with the highlighted rectangle
    output_image = image.replace(".jpeg", "_output.jpeg")
    cv2.imwrite(output_image, img)
    print("Output image saved as:", output_image)

    cv2.imshow("Image", img)
    cv2.waitKey(0)
    cv2.destroyAllWindows()