


with open("locsAndCounties 1. – Unmerged.csv","r",encoding="utf-8") as f:
    source = f.read().split("\n")

for line in source:

    line = line.split(";")
    line.pop(0)

    line.insert(3, "',\n],")
    line.insert(2, "',\n    'holding_id' => '")
    line.insert(1, "',\n    'name' => '")
    line.insert(0, "[\n    'postalCode' => '")

    print("".join(line))
