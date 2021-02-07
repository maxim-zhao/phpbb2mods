These are tools to test and create btf fonts from ttf fonts


- vc_test.php: Allows to test the various images.
To be copied at root of phpBB and removed once tests done.
To switch between GD generation and not-GD generation, edit the file, and set the constant GD to true or false.

- vc_create_btf.php: allows to create .btf fonts from .ttf fonts
This one is to use on a system supporting GD to create .btf fonts from the ttf fonts available. It will create them
in includes/vc/fonts if the font does not exists. I suggest to use it only on a local setup, as it requires the
write ability onto the includes/vc/fonts directory, then to upload to the remote server the .btf generated.