package functions

import (
	"fmt"
	"math"
	"strconv"
	"strings"
)

func GetAverage(input_text string) int {
	lines := strings.Split(input_text, "newline")
	total := 0
	var marks []int
	for _, line := range lines {
		line := strings.Split(line, ",")
		mark := (line[1])
		//remove whitespaces and convert to int
		mark = strings.TrimSpace(mark)
		intMark, err := strconv.Atoi(mark)
		if err == nil {
			marks = append(marks, intMark)
			total = total + intMark
		}
	}
	var average float64
	average = float64(total / len(marks))
	average = math.Round(average)
	var averageInt int = int(average)
	return averageInt
}

func GetClassification(average int) string {
	classification := ""
	if average < 50 {
		classification = "Fail"
		fmt.Println(classification)
	} else if average >= 50 && average <= 59 {
		classification = "Pass"
	} else if average >= 60 && average <= 69 {
		classification = "Merit"
	} else if average > 70 {
		classification = "Distinction"
	}
	return classification
}
