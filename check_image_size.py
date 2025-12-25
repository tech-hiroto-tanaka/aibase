import os
from PIL import Image

def get_image_size(path):
    try:
        with Image.open(path) as img:
            return img.size
    except Exception as e:
        return str(e)

current_logo_path = r'd:\workspace\900_toys\002_atsumare\aibase\public\assets\img\user\main_logo.png'
print(f"Current logo size: {get_image_size(current_logo_path)}")
