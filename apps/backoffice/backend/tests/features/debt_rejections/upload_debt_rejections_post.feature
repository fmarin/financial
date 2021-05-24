Feature: Uploading debt rejections file as part of request
  In order to upload a debt rejections file from bank
  As a financial user
  I should be able to send a request that contains a file

  Scenario: I can send request with a file attached to it
    When I attach the file "DDddmmyy.000.xml" with mime type "application/xml" from path "apps/backoffice/backend/tests/files/" to the request
    Then I send a POST request to "/upload-debt-rejections"
    Then the response content should be:
    """
    {
      "file-name": "DDddmmyy.000.xml",
      "uploaded": true
    }
    """