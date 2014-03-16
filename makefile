commit:
	@git add .
	@git commit -am"$(message) `date`" | :
push: commit
	@git push origin master --tags
.PHONY: push commit