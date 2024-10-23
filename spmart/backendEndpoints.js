// Copyright Amazon.com, Inc. or its affiliates. All Rights Reserved.
// SPDX-License-Identifier: MIT-0

/**
 * UPDATE ME - add endpoints after deploying the CFN template
 *
 * CloudFormation Template: https://github.com/amazon-connect/amazon-connect-chat-ui-examples/tree/master/cloudformationTemplates/startChatContactAPI
 * 
 * Prerequisites:
 *  - Amazon Connect Instance: https://docs.aws.amazon.com/connect/latest/adminguide/amazon-connect-instances.html
 *  - InstanceId: https://docs.aws.amazon.com/connect/latest/adminguide/find-instance-arn.html
 *  - ContactFlowId: https://docs.aws.amazon.com/connect/latest/adminguide/find-contact-flow-id.html
 */

var contactFlowId = "1d314f7f-64e2-4405-98b6-ab5e3352f881"; // TODO: Fill in
var instanceId = "72381907-5044-42c4-9700-cbe21f27fd69"; // TODO: Fill in
var apiGatewayEndpoint = "https://t2h5pru6sg.execute-api.ap-southeast-1.amazonaws.com/Prod"; // TODO: Fill in with the API Gateway endpoint created by your CloudFormation template
var region = "ap-southeast-1"; // TODO: Fill in
