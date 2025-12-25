import os
from PIL import Image

source_path = r'C:/Users/htana/.gemini/antigravity/brain/6d38c8ef-2c7c-4b94-b372-eb429a1c7457/uploaded_image_1766625181548.png'
target_path = r'd:\workspace\900_toys\002_atsumare\aibase\public\assets\img\user\logo_aibase.png'
target_width = 646

try:
    with Image.open(source_path) as img:
        # Calculate new height to maintain aspect ratio
        width_percent = (target_width / float(img.size[0]))
        target_height = int((float(img.size[1]) * float(width_percent)))
        
        # Resize
        new_img = img.resize((target_width, target_height), Image.Resampling.LANCZOS)
        
        # Save
        new_img.save(target_path)
        print(f"Image saved to {target_path} with size {new_img.size}")
except Exception as e:
    print(f"Error: {e}")
