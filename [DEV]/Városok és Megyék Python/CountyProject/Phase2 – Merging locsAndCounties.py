


with open("locsAndCounties 1. – Unmerged.csv","r",encoding="utf-8") as f:
    source = f.read().split("\n")


i = 1
while i < len(source):

    prevLine = source[i-1].split(";")
    currLine = source[i].split(";")
    print(i, prevLine, currLine)
    if len(currLine) != 4:
        print(f"ErrorC: {currLine}")
        i += 1

    elif len(currLine) != 4:
        print(f"ErrorP: {prevLine}")
        i += 1

    elif currLine[2] == prevLine[2]:
        prevLine[1] += f",{currLine[1]}"
        source.pop(i)

    else:
        i += 1

    source[i-1] = ";".join(prevLine)


with open("locsAndCounties 2. – Merged.csv","w",encoding="utf-8") as f:
    f.write("\n".join(source))
