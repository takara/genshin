gensin: main.php src/*
	box compile

install: ~/.bin/gensin

~/.bin/gensin: gensin
	cp gensin ~/.bin/gensin

clean:
	rm gensin
	
reinstall: clean install
