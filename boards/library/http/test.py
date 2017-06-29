#!/usr/bin/env python

import requests as HTTP
import json as JSON
import time as LORD
import random as JITTER

id = 8910787
url = "http://api.heclouds.com/devices/%d/datapoints" % id
headers = {
    "api-key": "kgyKoDtZXfopL3=RX4T4WkoCdMA="
}

interval = 5
tries = 3

while tries:
    json = {
        "datastreams": [
                {
                    "id": "volt",
                    "datapoints":
                    [
                        {
                            "at": "",
                            "value": 380 + JITTER.random()*10-5.0
                        }
                    ]
                },
                {
                    "id": "ampere",
                    "datapoints":
                    [
                        {
                            "at": "",
                            "value": 38 + JITTER.random()*5-2.5
                        }
                    ]
                },
    #            {
    #                "id": "location",
    #                "datapoints":
    #                [
    #                    {
    #                        "at": "",
    #                        "value": "110.0848103E#34.4778708N"
    #                    }
    #                ]
    #            },
                {
                    "id": "onoff",
                    "datapoints":
                    [
                        {
                            "at": "",
                            "value": JITTER.choice(("on", "off"))
                        }
                    ]
                }
            ]
    }

    r = HTTP.post(url, headers=headers, json=json)
    s = JSON.loads(r.text).get("error")

    LORD.sleep(interval);

    if s != "succ":
        tries -= 1
