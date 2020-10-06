imageoverlay
============

PHP utility that generates images from a template image and dynamic overlay text.

Components:
- A template selector.
- A template settings editor.
- A file upload utility.
- An image generator.

Settings per template:
- Margins: left, right, top and bottom.
- Text settings for field #1:
  -- Font face
  -- Color
  -- Size
  -- Horizontal alignment
  -- Vertical alignment
- Text settings for fields #2..n
  -- (as above)

To view a generated image:
```
  https://host/imageoverlay/image.php/TemplateName?t1=some_text&t2=some_more
```
