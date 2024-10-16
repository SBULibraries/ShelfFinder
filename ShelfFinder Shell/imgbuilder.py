#These libraries will need to be installed.
import cv2
import numpy as np
import urllib.request
import base64
import sys


#This function takes the base image and locator icon and overlays them for a particular item.
def generateImage(background_img_url,icon_img_url,icon_img_zoom,pixel_x,pixel_y):

    with urllib.request.urlopen(background_img_url) as resp: 
        background_img = np.asarray(bytearray(resp.read()), dtype="uint8") 
        background_img = cv2.imdecode(background_img, cv2.IMREAD_COLOR)

    with urllib.request.urlopen(icon_img_url) as resp: 
        icon_img = np.asarray(bytearray(resp.read()), dtype="uint8") 
        icon_img = cv2.imdecode(icon_img, cv2.COLOR_GRAY2BGR)
        

    icon_img = icon_img.astype(np.float32)
    icon_img = zoom_at(icon_img,icon_img_zoom)
    
    background_height, background_width, _ = background_img.shape
    icon_height, icon_width, _ = icon_img.shape
    icon_height=icon_height*icon_img_zoom
    icon_width=icon_width*icon_img_zoom

    absolute_x = int(pixel_x)
    absolute_y = int(pixel_y)

    absolute_x = min(background_width - icon_width, max(0, absolute_x))
    absolute_y = min(background_height - icon_height, max(0, absolute_y))

    alpha_channel = icon_img[:, :, 3] / 255.0

    for c in range(0, 3):
        background_img[absolute_y:absolute_y + icon_height, absolute_x:absolute_x + icon_width, c] = (
            alpha_channel * icon_img[:, :, c] + (1 - alpha_channel) * background_img[
                absolute_y:absolute_y + icon_height, absolute_x:absolute_x + icon_width, c]
        ).astype(background_img.dtype)

    _, image_buffer = cv2.imencode('.png', background_img)
    image_string = base64.b64encode(image_buffer).decode()

    return f'data:image/png;base64,{image_string}'
#This controls the level of zoom on click on the image.
def zoom_at(img, zoom, coord=None):
    h, w, _ = [ zoom * i for i in img.shape ]
    
    if coord is None: cx, cy = w/2, h/2
    else: cx, cy = [ zoom*c for c in coord ]
    
    img = cv2.resize( img, (0, 0), fx=zoom, fy=zoom)
    img = img[ int(round(cy - h/zoom * .5)) : int(round(cy + h/zoom * .5)),
               int(round(cx - w/zoom * .5)) : int(round(cx + w/zoom * .5)),
               : ]
    
    return img
img=generateImage(
    sys.argv[1]
    ,sys.argv[2]
    ,int(sys.argv[3])
    ,int(sys.argv[4])
    ,int(sys.argv[5])
    )
print(img)
