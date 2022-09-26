package main

import (
	functions "./functions"

	"testing"
)

func TestGetAverage(t *testing.T) {
	input_text := "Module1,90newlineModule2,80newlineModule3,90"
	answer := functions.GetAverage(input_text)

	if answer != 86 {
		t.Error("Expected 86 got ", answer)
	}
}

func TestGetClassification(t *testing.T) {
	average := 60
	answer := functions.GetClassification(average)
	if answer != "Merit" {
		t.Error("Expected Merit got ", answer)
	}
}
